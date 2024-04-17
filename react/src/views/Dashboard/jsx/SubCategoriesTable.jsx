
import React,{useEffect,useState} from 'react'
import "../css/dash-table.css"
import axios from "axios"
export default function DashTable() {
    
    const [subcategories,setSubcategories]=useState([]);
    const [subcategoriescopy,setSubcategoriescopy]=useState([]);
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
        document.querySelector(".subcategoriesOpt").classList.add("active")
    }

    useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/subcategories")
        .then(result =>{ setSubcategories(result["data"]['subcategories']);setSubcategoriescopy(subcategories.slice(0,15));})
        .catch(error =>console.log(error));       
        setActive();
        setPageNb(Math.ceil(subcategories.length / showNb))
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
      setSubcategoriescopy(subcategories.slice(from,to))
      setPageNb(Math.ceil(subcategories.length / showNb))
    },[subcategories,showNb])

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
      setSubcategoriescopy(subcategories.slice(from,to))
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
    function deleteSubCat(id){
      let from=(currentPage - 1) * showNb
      let to=from+ parseInt(showNb)
      axios.delete("http://127.0.0.1:8000/api/subcategory/" + id+ "/delete")
        .then(result =>{console.log("Product deleted succssuly");
        setSubcategories(subcategories.filter(prod => prod.id !== id));
      })
        .catch(error =>console.log(error));
        setSubcategoriescopy(subcategories.slice(from, to));
    }
    
  return (
    <div className='dash-table'>
        <div class="datatable-container">
  

  <table class="datatable">
    <thead>
      <tr>

        <th>Id</th>
        <th>Name</th>
        <th>Main Category</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
        {subcategoriescopy.map(ele=>{
            return(
                <tr key={ele.id}>
                    <td>{ele.id}</td>
                    <td>{ele.name}</td>
                    <td>{ele.category_parent.name}</td>
                    <td><button>
            <i class="material-icons">edit</i>
          </button><button onClick={() =>deleteSubCat(ele.id)}>
            <i class="material-icons">delete</i>
          </button></td>
                </tr>
            )
        }

        )}
     
    </tbody>
  </table>

  
 
</div>
    <div class="footer-tools">
      <div class="list-items">
        Show
        <select name="n-entries" id="n-entries" class="n-entries" onChange={onOptionChangeHandler}>
          <option value="15"  selected>15</option>
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
