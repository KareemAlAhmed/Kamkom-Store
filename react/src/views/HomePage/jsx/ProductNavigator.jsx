import React from 'react'
import { useParams } from 'react-router-dom';
import ProductPage from './ProductPage';
import NotFound from '../../NotFound';
export default function ProductNavigator() {
    let { productId } = useParams();
    // userId = parseInt(userId, 10);
    const isValidUserId = /^\d+$/.test(productId);
  
    return (
      <>
        {isValidUserId ? (<ProductPage />) : (<NotFound />)}
      </>
    );
  }
  
