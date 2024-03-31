import axios from "axios"
import React,{useEffect,useState} from 'react'
import { useStateContext } from "../context/contextProvider";

export default function HomePage() {

    const [products,setProducts]=useState([]);
      useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/products")
        .then(result => setProducts(result["data"]['prods']))
        .catch(error =>console.log(error));
    },[])
    const {user,token}=useStateContext();

  return (
    <div>
      <h1>Welcome {user}</h1>
        {products.map(prod =><p>{prod.name} with color {prod.color} and quantity of {prod.quantity} with cost {prod.price}</p>)}  
    </div>
  )
}

