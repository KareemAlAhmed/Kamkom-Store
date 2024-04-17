
import React,{useEffect,useState} from 'react'
import "../css/dash-table.css"
import axios from "axios"
export default function DashTable() {
    
    const [products,setProducts]=useState([]);
    useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/products")
        .then(result => setProducts(result["data"]['prods']))
        .catch(error =>console.log(error));
    },[])
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
        {products.map(ele=>{
            return(
                <tr key={ele.id}>
                    <td>{ele.id}</td>
                    <td>{ele.name}</td>
                    <td>{ele.brand_name}</td>
                    <td>${ele.price}</td>
                    <td>{ele.quantity}</td>
                    <td>{ele.star_number}</td>
                    <td>{ele.category_id}</td>
                    <td>{ele.user_id}</td>
                    <td><button>
            <i class="material-icons">edit</i>
          </button><button>
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
      <select name="n-entries" id="n-entries" class="n-entries">
        <option value="5">5</option>
        <option value="10" selected>10</option>
        <option value="15">15</option>
      </select>
      entries
    </div>

    <div class="pages">
      <ul>
        <li><span class="active">1</span></li>
        <li><button>2</button></li>
        <li><button>3</button></li>
        <li><button>4</button></li>
        <li><span>...</span></li>
        <li><button>9</button></li>
        <li><button>10</button></li>
      </ul>
    </div>
  </div>
    </div>
  )
}
