import React from 'react'
import "../css/options.css"
import { Link } from 'react-router-dom';
import { TfiPackage} from "react-icons/tfi";
import { HiOutlineUsers  } from "react-icons/hi";
import { TbTruckDelivery ,TbCategoryPlus} from "react-icons/tb";
import { BiCategory } from "react-icons/bi";





export default function Options() {
    function setActive(e){
        let lis=document.querySelectorAll(".link")
        Array.from(lis).map((li)=>{
            if (li.classList.contains("active")) {
                li.classList.remove("active");
            }

        })
        if(e.target.classList.contains("logo")){
            e.target.parent.classList.add("active")
        }else{
            e.target.classList.add("active")
        }
    }
  return (
    <div className='dashboard-options'>
        <ul>
            <li onClick={setActive}><Link className='link productsOpt' to="./products" > <TfiPackage  className='prodLogo logo'/> Products</Link></li>
            <li onClick={setActive}><Link className='link categoriesOpt' to="./categories"><BiCategory className='catLogo logo'/>Categories</Link></li>
            <li onClick={setActive}><Link className='link subcategoriesOpt ' to="./subcategories"><TbCategoryPlus className='catLogo logo'/>SubCategories</Link></li>
            <li onClick={setActive}><Link className='link ordersOpt' to="./orders"><TbTruckDelivery className='logo' />Orders</Link></li>
            <li onClick={setActive}><Link className='link usersOpt' to="./users"><HiOutlineUsers className='logo' />Users</Link></li>
        </ul>
    </div>
  )
}
