import { useParams } from "react-router-dom";
import Container from "../../components/containers/Container";
import Navbar from "../../components/navbar/Navbar";
// import { productsList } from "../../../utils/baseUrl";
import "./ProductDetails.css";
import Footer from "../../components/footer/Footer";
import { useSelector } from "react-redux";
import { useState } from "react";

const ProductDetails = () => {
    const [selectedImage, setSelectedImage] = useState(0);
    const id = useParams().id;
    const product = useSelector((state) => state.product.products.prods[id]);
    // const product = productsList[id];
    const images = JSON.parse(product.images_url);

    return (
        <>
            <Navbar />
            <Container>
                <div className="productDetailsPage">
                    <div className="productImg">
                        <img src={images[selectedImage]} alt={product?.name} />
                    </div>
                    <div className="prodcutDetails">
                        <h1>{product?.name}</h1>
                        <p>{product?.desc}</p>
                        <p>price : {product?.price}</p>
                        <p>in Stock || out of stock</p>
                        <button>back to shop</button>
                    </div>
                    <div className="productImages">
                        {images?.map((image, index) => (
                            <div
                                key={index}
                                onClick={() => setSelectedImage(index)}
                            >
                                <img
                                    className={
                                        selectedImage == index
                                            ? "imagesOfProduct selectedImage"
                                            : "imagesOfProduct"
                                    }
                                    src={image}
                                    alt={product?.name}
                                />
                            </div>
                        ))}
                    </div>
                </div>
            </Container>
            <Footer />
        </>
    );
};
export default ProductDetails;
