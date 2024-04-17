
import React,{useEffect,useState} from 'react'
import "../css/dash-table.css"
import axios from "axios"
export default function DashTable() {
    function formatTimestamp(timestampString) {
        // Validate input for robustness (optional)
        // if (!timestampString || !isValidTimestamp(timestampString)) {
        //   return 'Invalid timestamp format';
        // }

        // Parse the timestamp string into a JavaScript Date object
        const timestamp = new Date(timestampString);

        // Get year, month (0-indexed), day, hours (0-23), minutes with padding
        const year = timestamp.getFullYear();
        const month = String(timestamp.getMonth() + 1).padStart(2, '0'); // Add leading zero for single-digit months
        const day = String(timestamp.getDate()).padStart(2, '0');

        // Determine am/pm based on hours
        const hours = timestamp.getHours();
        const amPm = hours >= 12 ? 'pm' : 'am';

        // Format hours according to 12-hour clock (adjust for leading zero)
        const formattedHours = String((hours % 12) || 12).padStart(2, '0'); // 12 for midnight/noon

        // Get minutes with padding
        const minutes = String(timestamp.getMinutes()).padStart(2, '0');

        // Choose the desired format for the simpler timestamp
        const simpleFormat = `${year}-${month}-${day} ${formattedHours}:${minutes} ${amPm}`;

        // Return the formatted date and time
        return simpleFormat;
      }
    const [orders,setOrders]=useState([]);
    const [orderscopy,setOrderscopy]=useState([]);
    const [showNb,setShowNb]=useState(15);
    const [pageNb,setPageNb]=useState(0);
    const [currentPage,setCurrentPage]=useState(1);
    let pages=[]
    function setActive(){
        let lis=document.querySelectorAll(".link")
        Array.from(lis).map((li)=>{
            if (li.classList.contains("active")) {
                li.classList.remove("active");
            }

        })
        document.querySelector(".ordersOpt").classList.add("active")
    }
    useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/purchases")
        .then(result => {setOrders(result["data"]['purchases']);setOrderscopy(orders.slice(0,15));})
        .catch(error =>console.log(error));
        setActive();
        setPageNb(Math.ceil(orders.length / showNb));
    },[])
    for(let i =0;i<pageNb;i++){
      if(i == 0){
        pages.push(<button class="active page" onClick={setPageActive}>{i + 1}</button>)
      }else{
        pages.push(<button class="page" onClick={setPageActive}>{i + 1}</button>)
      }
      
    }
  useEffect(()=>{
    let from=(currentPage - 1) * showNb
    let to=from+ parseInt(showNb)
    setOrderscopy(orders.slice(from,to))
    setPageNb(Math.ceil(orders.length / showNb))
  },[orders,showNb])

  function setPageActive(e){
    let lis=document.querySelectorAll(".page")
    Array.from(lis).map((li)=>{
        if (li.classList.contains("active")) {
            li.classList.remove("active");
        }

    });
    e.target.classList.add("active")
    setCurrentPage(parseInt(e.target.innerHTML))
    let from=(e.target.innerHTML - 1)* showNb
    let to=from + parseInt(showNb)
    setOrderscopy(orders.slice(from,to))
  }    
  function setPageActive2(nb){
    let lis=document.querySelectorAll(".page")
    Array.from(lis).map((li)=>{
        if (li.innerHTML==1) {
            li.classList.add("active");
        }else{
          li.classList.remove("active");
        }

    });
  }    
  function formatPrice(number, fixedDecimals = 2) {
    const formattedNumber = number.toFixed(fixedDecimals).replace(/\d(?=(\d{3})+(?!\d))/g, ',');
    return `${formattedNumber}`; // Add currency symbol
  }
  const onOptionChangeHandler = (event) => {
    setShowNb(event.target.value);
    setPageActive2(1)
  };
  function deleteOrder(id){
    let from=(currentPage - 1) * showNb
    let to=from+ parseInt(showNb)
    axios.delete("http://127.0.0.1:8000/api/purchase/" + id+ "/delete")
      .then(result =>{console.log("Product deleted succssuly");
      setOrders(orders.filter(order => order.id !== id));
    })
      .catch(error =>console.log(error));
      setOrderscopy(orders.slice(from, to));
  }
  return (
    <div className='dash-table'>
        <div class="datatable-container">
  

  <table class="datatable">
    <thead>
      <tr>

        <th>Id</th>
        <th>Buyer</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total Paid</th>
        <th>Seller</th>
        <th>Date & Time</th>
        {/* <th>User_id</th> */}
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
        {orderscopy.map(ele=>{
            var data = JSON.parse(ele.products);
            var size = Object.keys(data).length;
            var keys=Object.keys(data);
           return keys.map(ind=>{
                console.log(data[ind].BuyerName)
                return( 
                    <tr key={ele.id}>
                        <td>{ele.id}</td>
                        
                        <td>{data[ind].BuyerName}</td>
                        <td>{data[ind].ProductName}</td>
                        <td>{data[ind].quantity}</td>
                        <td>${formatPrice(data[ind].quantity * data[ind].ProductPrice)}</td>
                        <td>{data[ind].seller}</td>
                        <td>{formatTimestamp(ele.created_at)}</td>
                        <td>
                            <button><i class="material-icons">edit</i></button>
                            <button onClick={() =>deleteOrder(ele.id)}><i class="material-icons">delete</i></button>
                        </td>
                    </tr>
                )
            })
     
       
        }

        )}
     
    </tbody>
  </table>

  
 
</div> <div class="footer-tools">
    <div class="list-items">
      Show
      <select name="n-entries" id="n-entries" class="n-entries" onChange={onOptionChangeHandler}>
        <option value="15" selected>15</option>
        <option value="20">20</option>
        <option value="25">25</option>
      </select>
      entries
    </div>

    <div class="pages">
      <ul>
      {pages.map( (ele,index)=>{
            return(
                <li key={index}>{ele}</li>
            )
          })}
      </ul>
    </div>
  </div>
    </div>
  )
}
