import Container from "../containers/Container";
import "./Banner.css";

const Banner = () => {
    return (
        <div className="Banner">
            <Container>
                <div className="bannerContainer">
                    <div className="bannerDetails bannerDetail">
                        <h2>welcome to your store</h2>
                        <p>
                            Here you can find anything you need at great offers
                            and height qquality. I hope you have a wonderful
                            visit
                        </p>
                        <div className="bannerBtn">
                            <button>Buy Now</button>
                            <button>Explore More</button>
                        </div>
                    </div>
                    <div className="bannerDetails bannerImage">
                        <img
                            src="https://spacehop.com/wp-content/uploads/2020/08/image-quality.jpg"
                            alt="banner"
                        />
                    </div>
                </div>
            </Container>
        </div>
    );
};
export default Banner;
