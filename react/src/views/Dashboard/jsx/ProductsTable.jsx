
import React,{useEffect,useState} from 'react'
import "../css/dash-table.css"
import axios from "axios"
export default function DashTable() {
    
    const [products,setProducts]=useState([]);
    const [productscopy,setProductscopy]=useState([]);
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
        document.querySelector(".productsOpt").classList.add("active")
    }
    useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/products")
        .then(result => {setProducts(result["data"]['prods']);setProductscopy(products.slice(0,15));})
        .catch(error =>console.log(error));
        setActive();       
        setPageNb(Math.ceil(products.length / showNb))
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
    setProductscopy(products.slice(from,to))
    setPageNb(Math.ceil(products.length / showNb))
  },[products,showNb])

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
      setProductscopy(products.slice(from,to))
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
    const onOptionChangeHandler = (event) => {
      setShowNb(event.target.value);
      setPageActive2(1)
    };
    function formatPrice(number, fixedDecimals = 2) {
      const formattedNumber = number.toFixed(fixedDecimals).replace(/\d(?=(\d{3})+(?!\d))/g, ',');
      return `${formattedNumber}`; // Add currency symbol
    }
    function deleteProduct(id){
      let from=(currentPage - 1) * showNb
      let to=from+ parseInt(showNb)
      axios.delete("http://127.0.0.1:8000/api/product/" + id+ "/delete")
        .then(result =>{console.log("Product deleted succssuly");
        setProducts(products.filter(prod => prod.id !== id));
      })
        .catch(error =>console.log(error));
        setProductscopy(products.slice(from, to));
    }
  return (
    <div className='dash-table'>
        <div class="datatable-container">
  

  <table class="datatable">
    <thead>
      <tr>

        <th>Id</th>
        <th>Name</th>
        <th>Brand_name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Star_number</th>
        <th>Category_id</th>
        <th>User_id</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
        {productscopy.map(ele=>{
            return(
                <tr key={ele.id}>
                    <td>{ele.id}</td>
                    <td>{ele.name}</td>
                    <td>{ele.brand_name}</td>
                    <td>${formatPrice(ele.price)}</td>
                    <td>{ele.quantity}</td>
                    <td>{ele.star_number}</td>
                    <td>{ele.category_id}</td>
                    <td>{ele.user_id}</td>
                    <td><button>
            <i class="material-icons">edit</i>
          </button><button onClick={() =>deleteProduct(ele.id)}>
            <i class="material-icons">delete</i>
          </button></td>
                </tr>
            )
        }

        )}
     
    </tbody>
  </table>

  
 
</div> <div class="footer-tools">
    <div class="list-items">
      Show
      <select name="n-entries" id="n-entries" class="n-entries" onChange={onOptionChangeHandler}>
        <option value="15" selected>15</option>
        <option value="20" >20</option>
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
