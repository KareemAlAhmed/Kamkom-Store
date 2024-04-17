import React from 'react'
import '../css/ProductShow.css'
import watchImage from '../watch.jpeg';
import perfumeImage from '../perfume.jpeg';


const products = [
    {
        id: '1',
        categorie: 'acces',
        name: 'Dior De Perfume',
        brand: 'rolex',
        price: '150',
        image: perfumeImage,
    },
    {
        id: '2',
        categorie: 'wt',
        name: 'Apple Watch P6 i-2',
        brand: 'smart watch',
        price: '320',
        image: watchImage,

    },
    {
        id: '3',
        categorie: 'wt',
        name: 'Apple Watch P6 i-2',
        brand: 'smart watch',
        price: '320',
        image: watchImage,

    },
    {
        id: '4',
        categorie: 'wt',
        name: 'Apple Watch P6 i-2',
        brand: 'smart watch',
        price: '320',
        image: watchImage,
    },
    {
        id: '5',
        categorie: 'wt',
        name: 'Apple Watch P6 i-2',
        brand: 'smart watch',
        price: '320',
        image: watchImage,
    },
    {
        id: '6',
        categorie: 'acces',
        name: 'Apple Watch P6 i-2',
        brand: 'smart watch',
        price: '320',
        image: perfumeImage,
    },
    {
        id: '7',
        categorie: 'acces',
        name: 'Apple Watch P6 i-2',
        brand: 'smart watch',
        price: '320',
        image: perfumeImage,
    },
    {
        id: '8',
        categorie: 'acces',
        name: 'Apple Watch P6 i-2',
        brand: 'smart watch',
        price: '320',
        image: perfumeImage,
    },

    {
        id: '9',
        categorie: 'acces',
        name: 'Dior De Perfume',
        brand: 'rolex',
        price: '150',
        image: perfumeImage,

    }
];
const shuffledData = [...products].sort(() => Math.random() - 0.5);
const fourProduct = shuffledData.slice(0, 4);
function ProductShow() {
    return (
        <>

                {fourProduct.map((fourProduct) => (
                    <div key={fourProduct.id} className='product-container'>
                            <a className='a-product' href='#'>
                                <img src={fourProduct.image} className='photo-product' alt='no have' />
                            <div className='detail-product'>
                                <h2 className='brand-product'> {fourProduct.name}  </h2>
                                <p className='type-product'> {fourProduct.brand} </p>
                                <h4 className='price-product'> {fourProduct.price}$ </h4>
                            </div>
                        </a>
                    </div>
                ))}
        </> 
    );
}

export default ProductShow
