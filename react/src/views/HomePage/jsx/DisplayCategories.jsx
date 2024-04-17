import ProductShow from './ProductShow'
import React,{useEffect,useState} from 'react'
import '../css/DisplayCat.css';
import axios from "axios"
const DisplayCategories = () => {
    const [products,setProducts]=useState([]);
    useEffect(()=>{
        axios.get("http://127.0.0.1:8000/api/products")
        .then(result =>{ let data=result["data"]['prods'];setProducts(data.slice(0,4))})
        .catch(error =>console.log(error));


    },[])
    return (
        <>

           <div className="popular slideDiv">
            <h1 className='title-show' >Popular</h1>
                <div className='productShowStyle'>
                    {products.map((ele) => (
                        <div key={ele.id} className='product-container'>
                                <a className='a-product' href='#'>
                                    <img src={"http://127.0.0.1:8000/storage/"+ele.thumbnail_url} className='photo-product' alt='no have' />
                                <div className='detail-product'>
                                    <h2 className='product-name'>{ele.name} </h2>
                                    <p className='product-brand'>{ele.brand_name}</p>
                                    <span className='product-price'>${ele.price}</span>
                                    <a href='#' className='addToCart' >Add To Cart</a>
                                </div>
                            </a>
                        </div>
                    ))}
                    <input type='submit' className='view-all' value='View All' />
                </div>
           </div>


            <div className="onsale slideDiv" >
                <h1 className='title-show' >Most Selling</h1>
                <div className='productShowStyle'>
                {products.map((ele) => (
                        <div key={ele.id} className='product-container'>
                                <a className='a-product' href='#'>
                                    <img src={"http://127.0.0.1:8000/storage/"+ele.thumbnail_url} className='photo-product' alt='no have' />
                                <div className='detail-product'>
                                    <h2 className='product-name'>{ele.name}</h2>
                                    <p className='product-brand'>{ele.brand_name}</p>
                                    <span className='product-price'>${ele.price}</span>
                                    <a href='#' className='addToCart' >Add To Cart</a>
                                </div>
                            </a>
                        </div>
                    ))}
                    <input type='submit' className='view-all' value='View All' />
                </div>
            </div>


            <div className="newCollection slideDiv" >
                <h1 className='title-show' >New Arrivals</h1>
                <div className='productShowStyle'>
                {products.map((ele) => (
                        <div key={ele.id} className='product-container'>
                                <a className='a-product' href='#'>
                                    <img src={"http://127.0.0.1:8000/storage/"+ele.thumbnail_url} className='photo-product' alt='no have' />
                                <div className='detail-product'>
                                    <h2 className='product-name'>{ele.name}</h2>
                                    <p className='product-brand'>{ele.brand_name}</p>
                                    <span className='product-price'>${ele.price}</span>
                                    <a href='#' className='addToCart' >Add To Cart</a>
                                </div>
                            </a>
                        </div>
                    ))}
                    <input type='submit' className='view-all' value='View All' />
                </div>
            </div>

        </>
    )
}

export default DisplayCategories
