import Container from "./components/containers/Container";
import Navbar from "./components/navbar/Navbar";
import Banner from "./components/banner/Banner";
import CategoriesSection from "./components/categories/CategoriesSection";
import Products from "./components/products/Products";
import Footer from "./components/footer/Footer";

const style = { position: "relative", top: "70px" };

export default function App() {
    return (
        <>
            <Navbar />

            <div style={style}>
                <Banner />
                <Container>
                    <CategoriesSection />
                    <Products />
                </Container>
            </div>
            <Footer />
        </>
    );
}
