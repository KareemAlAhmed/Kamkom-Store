import { useState } from "react";
import Form from "../../../components/form/Form";
import Input from "../../../components/input/Input";
import Select from "react-select";
import Dropzone from "react-dropzone";
import * as Yup from "Yup";
import { useFormik } from "formik";
import { useDispatch } from "react-redux";
import "./AddProduct.css";
import { addProductAction } from "../../../../redux/slices/Product";

import axios from "axios";



const formSchema = Yup.object({
    name: Yup.string().required("Name of product is required"),
    brand: Yup.string().required("Brand name is required"),
    description: Yup.string().required("description is required"),
    price: Yup.number().required("price is required & should be number"),
    quantity: Yup.number().required("quantity is required & should be number"),
    vendor: Yup.string().required("vendor of product is required"),
});

const category = [
    { value: "Laptops", label: "Laptops" },
    { value: "Desktops", label: "Desktops" },
    { value: "Furniture", label: "Furniture" },
    { value: "Gaming", label: "Gaming" },
    { value: "Fashion", label: "Fashion" },
    { value: "Mobile", label: "Mobile" },
    { value: "Property", label: "Property" },
    { value: "Tablet", label: "Tablet" },
    { value: "Computer-Parts", label: "Computer-Parts" },
    { value: "Networking", label: "Networking" },
];

const AddProduct = () => {
    const [selectedCategory, setSelectedCategory] = useState({
        value: "Laptops",
    });
    const [images, setImages] = useState([]);
    const [imagesError, setImagesError] = useState(false);
    const dispatch = useDispatch();

    const formik = useFormik({
        initialValues: {
            name: "",
            brand: "",
            quantity: "",
            description: "",
            price: "",
            vendor: "",
        },
        onSubmit: (values) => {
            if (images.length === 0) {
                console.log("images Error ");
                setImagesError(true);
                return;
            }
            console.log({
                ...values,
                category: selectedCategory.value,
                images_url: JSON.stringify(images),
            });
            axios.post(`http://127.0.0.1:8000/api/product/create/user/1/cate/1`, {
                ...values,
                category: selectedCategory.value,
                images_url: JSON.stringify(images)
            })
            .then(res=>console.log(res)) 
            .catch(err=>console.log(err))
            ;
            // dispatch(
            //     addProductAction({
            //         ...values,
            //         category: selectedCategory.value,
            //         images_url: JSON.stringify(images),
            //     })
            // );

            // setImages([]);
            // setSelectedCategory({ value: "Laptops" });
            // formik.resetForm();
        },
        validationSchema: formSchema,
    });

    return (
        <>
            <div className="authPage">
                <Form title="Add Product" onSubmit={formik.handleSubmit}>
                    {formik.errors.name && formik.touched.name ? (
                        <p className="inputError">{formik.errors.name}</p>
                    ) : (
                        <></>
                    )}
                    <Input
                        type="text"
                        name="Name"
                        label="Name"
                        placeholder="Name"
                        fullWidth
                        value={formik.values.name}
                        onChange={formik.handleChange("name")}
                        onBlur={formik.handleBlur("name")}
                    />
                    {formik.errors.brand && formik.touched.brand ? (
                        <p className="inputError">{formik.errors.brand}</p>
                    ) : (
                        <></>
                    )}
                    <Input
                        type="text"
                        name="Brand"
                        label="Brand"
                        placeholder="Brand"
                        fullWidth
                        value={formik.values.brand}
                        onChange={formik.handleChange("brand")}
                        onBlur={formik.handleBlur("brand")}
                    />
                    {imagesError ? (
                        <p className="inputError">
                            {" "}
                            please provide the product images
                        </p>
                    ) : (
                        <></>
                    )}
                    <Dropzone
                        onDrop={(acceptedFiles) => setImages(acceptedFiles)}
                        accept="image/png image/jpeg"
                        onBlur={formik.handleBlur("image")}
                    >
                        {({ getRootProps, getInputProps }) => (
                            <div className="inputContainer">
                                <div
                                    {...getRootProps({
                                        className: "dropzone",
                                        onDrop: (event) =>
                                            event.stopPropagation(),
                                    })}
                                >
                                    <input {...getInputProps()} />
                                    <p
                                        onClick={() => {
                                            setImagesError(false);
                                        }}
                                        className="addImageInputBtn"
                                    >
                                        + Add the product images here
                                    </p>
                                </div>
                            </div>
                        )}
                    </Dropzone>
                    {formik.errors.description && formik.touched.description ? (
                        <p className="inputError">
                            {formik.errors.description}
                        </p>
                    ) : (
                        <></>
                    )}

                    <Input
                        type="text"
                        name="Description"
                        label="Description"
                        placeholder="Description"
                        fullWidth
                        value={formik.values.description}
                        onChange={formik.handleChange("description")}
                        onBlur={formik.handleBlur("description")}
                    />

                    {formik.errors.price && formik.touched.price ? (
                        <p className="inputError">{formik.errors.price}</p>
                    ) : (
                        <></>
                    )}
                    <Input
                        type="text"
                        name="Price"
                        label="Price"
                        placeholder="Price in $"
                        fullWidth
                        value={formik.values.price}
                        onChange={formik.handleChange("price")}
                        onBlur={formik.handleBlur("price")}
                    />

                    {formik.errors.quantity && formik.touched.quantity ? (
                        <p className="inputError">{formik.errors.quantity}</p>
                    ) : (
                        <></>
                    )}

                    <Input
                        type="text"
                        name="Quantity"
                        label="Quantity"
                        placeholder="Quantity"
                        fullWidth
                        value={formik.values.quantity}
                        onChange={formik.handleChange("quantity")}
                        onBlur={formik.handleBlur("quantity")}
                    />
                    <label>Category</label>
                    <Select
                        defaultValue={null}
                        onChange={setSelectedCategory}
                        options={category}
                        className="Input selectInput"
                        placeholder="Please Select Category , default (Laptops)..."
                    />

                    {formik.errors.vendor && formik.touched.vendor ? (
                        <p className="inputError">{formik.errors.vendor}</p>
                    ) : (
                        <></>
                    )}

                    <Input
                        type="text"
                        name="Vendor"
                        label="Vendor"
                        placeholder="Vendor"
                        fullWidth
                        value={formik.values.vendor}
                        onChange={formik.handleChange("vendor")}
                        onBlur={formik.handleBlur("vendor")}
                    />
                    <div className="submitBtn">
                        <input
                            type="submit"
                            value="submit"
                            className="disabledInputSumbitBtn"
                        />
                    </div>
                </Form>
            </div>
        </>
    );
};
export default AddProduct;
