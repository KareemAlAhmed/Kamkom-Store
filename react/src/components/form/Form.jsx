import { IoMdCloseCircle } from "react-icons/io";
import "./Form.css";
import { Link } from "react-router-dom";

const Form = (props) => {
    return (
        <div className="formContainer">
            {props.withCloseBtn ? (
                <div className="closeIcon">
                    <Link to="/">
                        <IoMdCloseCircle size={25} />
                    </Link>
                </div>
            ) : (
                <></>
            )}

            <div>
                <h1>{props.title}</h1>
                <form action="" onSubmit={props.onSubmit}>
                    {props.children}
                </form>
            </div>
        </div>
    );
};
export default Form;
