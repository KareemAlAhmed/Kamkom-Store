import { FaBiohazard } from "react-icons/fa";
import Container from "../../components/containers/Container";
import Navbar from "../../components/navbar/Navbar";
import "./UserProfile.css";

const UserProfile = () => {
    const user = {
        firstName: "ali",
        lastName: "ahmad",
        bio: "Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.",
        email: "ali@gmail.com",
        userImage:
            "https://t3.ftcdn.net/jpg/02/43/12/34/360_F_243123463_zTooub557xEWABDLk0jJklDyLSGl2jrr.jpg",
        country: "lebanon",
        city: "tripoli",
        province: "north",
        streetAddress: "110b",
        isUserAdmin: true,
    };
    return (
        <>
            <Navbar />
            <div className="UserProfile">
                <Container>
                    <div className="profileDetails">
                        <div className="userProfileInfo1">
                            <img src={user.userImage} alt="image of user" />
                            <p>
                                {user.firstName} {user.lastName}
                            </p>
                        </div>
                        <div className="userProfileInfo2">
                            <ul>
                                <li>Bio : {user.bio}</li>
                                <li>Country : {user.country}</li>
                                <li>City : {user.city}</li>
                                <li>Province : {user.province}</li>
                                <li>Street Address : {user.streetAddress}</li>
                                {user.isUserAdmin ? (
                                    <li className="adminProfile">
                                        Admin Account
                                    </li>
                                ) : (
                                    <li className="clientProflie">
                                        Client Account
                                    </li>
                                )}
                            </ul>
                        </div>
                    </div>
                </Container>
            </div>
        </>
    );
};
export default UserProfile;
