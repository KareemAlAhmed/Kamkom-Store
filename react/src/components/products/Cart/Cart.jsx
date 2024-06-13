import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { truncateText } from "../../../../utils/truncate";
import "./Cart.css";

const Cart = ({ product }) => {
    const [inCart, setInCart] = useState(false);
    const navigate = useNavigate();

    let items = JSON.parse(localStorage.getItem("cart")) || [];

    const nagivateToDetails = () => {
        navigate("/product/" + product?.id);
    };

    const addToCart = () => {
        items = JSON.parse(localStorage.getItem("cart"));
        if (items == null) {
            items = [];
        }
        const item = {
            id: product?.id,
            imgUrl: product?.thumbnail_url,
            name: product?.name,
            price: product?.price,
            quantity: 1,
        };
        items?.push(item);
        localStorage.setItem("cart", JSON.stringify(items));
        setInCart(true);
    };

    useEffect(() => {
        if (items?.find((item) => item?.id === product?.id)) setInCart(true);
        else setInCart(false);
    }, [addToCart]);

    return (
        <div className="cart" onClick={nagivateToDetails}>
            <div>
                <img src={product?.thumbnail_url} alt={product?.name} />
            </div>

            <div className="porductdetails">
                {/* <p>{product?.name}</p> */}
                <p>{truncateText(product?.name)}</p>
                <p>{product?.price}$</p>
                {inCart ? (
                    <div>Added to your cart</div>
                ) : (
                    <button
                        onClick={(e) => {
                            e.stopPropagation();
                            addToCart();
                        }}
                    >
                        Add To Cart
                    </button>
                )}
            </div>
        </div>
    );
};
export default Cart;
