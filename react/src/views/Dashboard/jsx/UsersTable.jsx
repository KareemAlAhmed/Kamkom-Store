
import React,{useEffect,useState} from 'react'
import "../css/dash-table.css"
import axios from "axios"
export default function DashTable() {
    
    const [users,setUsers]=useState([]);
    const [userscopy,setUserscopy]=useState([]);
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
        document.querySelector(".usersOpt").classList.add("active")
    }
    useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/users")
        .then(result =>{ setUsers(result["data"]['users']);setUserscopy(users.slice(0,15));})
        .catch(error =>console.log(error));
        setActive();
        setPageNb(Math.ceil(users.length / showNb))
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
      setUserscopy(users.slice(from,to))
      setPageNb(Math.ceil(users.length / showNb))
    },[users,showNb])

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
      setUserscopy(users.slice(from,to))
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

    function deleteUser(id){
      let from=(currentPage - 1) * showNb
      let to=from+ parseInt(showNb)
      axios.post("http://127.0.0.1:8000/api/user/" + id+ "/delete")
        .then(result =>{console.log("User deleted succssuly");
        setUsers(users.filter(user => user.id !== id));
      })
        .catch(error =>console.log(error));
        setUserscopy(users.slice(from, to));
    }
  return (
    <div className='dash-table'>
        <div class="datatable-container">
  

  <table class="datatable">
    <thead>
      <tr>

        <th>Id</th>
        <th>FirstName</th>
        <th>SecondName</th>
        <th>Email</th>
        <th>Balance</th>
        <th>Mobile Number</th>
        <th>Country</th>
        <th>City</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
        {userscopy.map((ele,index)=>{
            return(
                <tr key={index}>
                    <td>{ele.id}</td>
                    <td>{ele.firstName}</td>
                    <td>{ele.secondName}</td>
                    <td>{ele.email}</td>
                    <td>${formatPrice(ele.balance)}</td>
                    <td>{ele.mobile_number}</td>
                    <td>{ele.country}</td>
                    <td>{ele.city}</td>
                    <td><button>
            <i class="material-icons">edit</i>
          </button><button onClick={() =>deleteUser(ele.id)}>
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
