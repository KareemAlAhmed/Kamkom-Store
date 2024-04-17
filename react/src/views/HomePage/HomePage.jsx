import axios from "axios"
import React,{useEffect,useState} from 'react'
import { useStateContext } from "../../context/contextProvider";
import Navbar from "./jsx/Navbar"
import Header from "./jsx/Header"
import DisplayCategories from"./jsx/DisplayCategories"
import Footer from "./jsx/Footer"

export default function HomePage() {

    const [products,setProducts]=useState([]);
      useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/products")
        .then(result => setProducts(result["data"]['prods']))
        .catch(error =>console.log(error));
    },[])
    const {user,token}=useStateContext();

  return (
    <div className="homePage">
      <Navbar />
      <div className='big-container'>
        <Header />
        <DisplayCategories />
      </div>
      <Footer />
    </div>
  )
}

