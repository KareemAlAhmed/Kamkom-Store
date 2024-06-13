import Container from "../containers/Container";
import { FaHeart } from "react-icons/fa";
import { BsBasket3Fill } from "react-icons/bs";
import { IoPersonSharp } from "react-icons/io5";
import { Link, useNavigate } from "react-router-dom";
import "./Navbar.css";
import { useState } from "react";

const Navbar = () => {
    const [productToSearchOn, setProductToSearchOn] = useState("");
    const [displayMenu, setDisplayMenu] = useState(true);
    const isUserLogin = false;
    const navigate = useNavigate();

    const searchOnProduct = () => {
        navigate("/search", {
            state: productToSearchOn,
        });
    };
    return (
        <div className="nav">
            <Container>
                <div className="navItems">
                    <div className="navItem">
                        <Link to="/">
                            <h1>KamKom</h1>
                        </Link>
                    </div>
                    <div className="navItem navItemAndMenu">
                        <div className="navMenu">
                            <Link to="/dashboard/products">
                                <div className="MenuItem">Dashboard</div>
                            </Link>

                            <Link to="/cart">
                                <div className="MenuItem">cart</div>
                            </Link>

                            <div className="MenuItem">about</div>
                            <div className="MenuItem">contact us</div>
                        </div>
                    </div>
                    <div className="navItem">
                        <div className="search" onClick={searchOnProduct}>
                            {/* <div className="searchIcon">
                                <FaSearch />
                            </div> */}
                            <input
                                className="searchInput"
                                type="text"
                                placeholder="search"
                                value={productToSearchOn}
                                onChange={(e) => {
                                    setProductToSearchOn(e.target.value);
                                    navigate("/search", {
                                        state: e.target.value,
                                    });
                                }}
                            />
                        </div>
                    </div>
                    <div className="navItem disable">
                        {!isUserLogin ? (
                            <div className="navIcons ">
                                <div className="navIcon">
                                    <FaHeart />
                                </div>
                                <div className="navIcon">
                                    <Link to="/cart">
                                        <BsBasket3Fill />
                                    </Link>
                                </div>
                                <div className="navIcon">
                                    <Link to="/profile">
                                        <IoPersonSharp />
                                    </Link>
                                </div>
                            </div>
                        ) : (
                            <Link to="/auth">
                                <div className="SignInBtn">Login</div>
                            </Link>
                        )}
                    </div>
                    <div
                        className="navItem burgerNav undisable"
                        onClick={() => {
                            setDisplayMenu(!displayMenu);
                        }}
                    >
                        OOO
                    </div>
                </div>
            </Container>
            <div className={displayMenu ? "menu undisable" : "disable"}>
                <Link to="/dashboard/products">
                    <div className="MenuItem">Dashboard</div>
                </Link>

                <Link to="/cart">
                    <div className="MenuItem">Cart</div>
                </Link>

                <Link to="/profile">
                    <div className="MenuItem">Profile</div>
                </Link>

                <div className="MenuItem">About</div>
                <div className="MenuItem">Contact us</div>
            </div>
        </div>
    );
};
export default Navbar;
