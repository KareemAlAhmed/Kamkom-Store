import "./ShoppingCart.css";
import Navbar from "../../components/navbar/Navbar";
import Container from "../../components/containers/Container";
import { productsList } from "../../../utils/baseUrl";
import Footer from "../../components/footer/Footer";
import { useEffect, useState } from "react";

const ShoppingCart = () => {
    const [items, setItems] = useState([]);
    const [total, setTotal] = useState(0);

    const getTotal = () => {
        setTotal(0);
        items?.map((item) => {
            setTotal((prev) => (prev += item.quantity * item.price));
        });
    };

    useEffect(() => {
        setItems(JSON.parse(localStorage.getItem("cart")));
        getTotal();
    }, []);

    const incQty = (id) => {
        items?.map((item, index) => {
            if (item?.id === id) {
                console.log(id);
                items[index].quantity++;
                localStorage.setItem("cart", JSON.stringify(items));
                setItems(JSON.parse(localStorage.getItem("cart")));
            }
        });
        getTotal();
    };
    const decQty = (id) => {
        items?.map((item, index) => {
            if (item?.id === id) {
                if (item.quantity == 1) items.splice(index, 1);
                else items[index].quantity--;
                localStorage.setItem("cart", JSON.stringify(items));
                setItems(JSON.parse(localStorage.getItem("cart")));
            }
        });
        getTotal();
    };

    const deleteItem = (id) => {
        items?.map((item, index) => {
            if (item?.id === id) {
                items.splice(index, 1);
                localStorage.setItem("cart", JSON.stringify(items));
                setItems(JSON.parse(localStorage.getItem("cart")));
            }
        });
        getTotal();
    };

    return (
        <>
            <Navbar />
            <Container>
                <div className="shoppingCart">
                    <h1>My Shopping Cart</h1>
                    <div className="cartItems">
                        {items?.map((item, index) => (
                            <div key={index} className="cartItem">
                                <span
                                    className="deleteItem"
                                    onClick={() => {
                                        deleteItem(item?.id);
                                    }}
                                >
                                    X
                                </span>
                                <div className="itemImg">
                                    <img src={item.imgUrl} alt={item.name} />
                                </div>
                                <div className="itemDetails">
                                    <p>{item?.name}</p>
                                </div>
                                <div>Price : {item?.price}$</div>
                                <div className="itemQty">
                                    <button onClick={() => incQty(item?.id)}>
                                        +
                                    </button>
                                    <span>{item?.quantity}</span>
                                    <button onClick={() => decQty(item?.id)}>
                                        -
                                    </button>
                                </div>
                                <div>
                                    <p>
                                        Total Price:{" "}
                                        {item?.price * item?.quantity}$
                                    </p>
                                </div>
                            </div>
                        ))}
                        <hr />
                        <div className="checkoutsection">
                            <div>
                                {" "}
                                <p>Total: {total}$</p>
                            </div>
                            <div>
                                <button>Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
            <Footer />
        </>
    );
};
export default ShoppingCart;
