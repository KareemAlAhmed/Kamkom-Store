import { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import Cart from "./Cart/Cart";
import Container from "../containers/Container";
import { fetchProductByCategoryAction } from "../../../redux/slices/Product";

import "./Products.css";

const Products = () => {
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(fetchProductByCategoryAction("Laptops"));
    }, []);

    const { products } = useSelector((state) => state?.product);

    return (
        <Container>
            <div className="products">
                {products?.prods?.map((prod, index) => (
                    <div className="cartContainer" key={index}>
                        <Cart product={prod} />
                    </div>
                ))}
            </div>
        </Container>
    );
};
export default Products;
