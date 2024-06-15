import { createSlice, createAsyncThunk, createAction } from "@reduxjs/toolkit";

import axios from "axios";
import baseUrl from "../../utils/baseUrl";

const redirectAction = createAction("redirect");

export const addProductAction = createAsyncThunk(
    "/add-product",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        // const { token } = JSON.parse(localStorage.getItem("user-auth"));

        // const config = {
        //     headers: {
        //         Authorization: `bearer ${token}`,
        //     },
        // };
        // const formData = new FormData();

        // formData.append("images", payload?.images[0]);
        // formData.append("images", payload?.images[1]);
        // formData.append("images", payload?.images[2]);
        // formData.append("title", payload?.title);
        // formData.append("desc", payload?.desc);
        // formData.append("category", payload?.category);
        // formData.append("price", payload?.price);
        // formData.append("phoneNum", payload?.phoneNum);
        // formData.append("condition", payload?.condition);

        try {
            const { data } = axios.post(`${baseUrl}/product/create/user/1/cate/1`, payload);
            console.log(data)
            return data;
        } catch (error) {
            if (!error.response) {
                return error;
            }
            console.log(error)
            return rejectWithValue(error?.response?.data);
        }
    }
);

export const updateProductDetailsAction = createAsyncThunk(
    "/add-product",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const { token } = JSON.parse(localStorage.getItem("user-auth"));

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };
        const formData = new FormData();

        formData.append("images", payload?.images[0]);
        formData.append("images", payload?.images[1]);
        formData.append("images", payload?.images[2]);
        formData.append("title", payload?.title);
        formData.append("desc", payload?.desc);
        formData.append("category", payload?.category);
        formData.append("price", payload?.price);
        formData.append("phoneNum", payload?.phoneNum);
        formData.append("condition", payload?.condition);

        try {
            const { data } = axios.put(
                `${baseUrl}/product/${payload?.id}`,
                formData,
                config
            );

            return data;
        } catch (error) {
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);

export const fetchProductsAction = createAsyncThunk(
    "fecth-products",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        // const { token } = JSON.parse(localStorage.getItem("user-auth"));

        // const config = {
        //     headers: {
        //         Authorization: `bearer ${token}`,
        //     },
        // };
        try {
            //const { data } = await axios.get(`${baseUrl}/products`, config);
            const { data } = await axios.get(`${baseUrl}/products`);
            return data;
        } catch (error) {
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);
export const fetchProductByCategoryAction = createAsyncThunk(
    "category-products",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        // const { token } = JSON.parse(localStorage.getItem("user-auth"));

        // const config = {
        //     headers: {
        //         Authorization: `bearer ${token}`,
        //     },
        // };
        try {
            const { data } = await axios.get(
                `${baseUrl}/product/searchByCat/${payload}`
            );
            return data;
        } catch (error) {
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);

export const getProductDetailsAction = createAsyncThunk(
    "product-details",

    async (payload, { rejectWithValue, getState, dispatch }) => {
        const { token } = JSON.parse(localStorage.getItem("user-auth"));

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.get(
                `${baseUrl}/product/details/${payload}`,
                config
            );
            return data;
        } catch (error) {
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);
export const increaseProductViewedAction = createAsyncThunk(
    "product-viewed",

    async (payload, { rejectWithValue, getState, dispatch }) => {
        const { token } = JSON.parse(localStorage.getItem("user-auth"));

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.put(
                `${baseUrl}/product/views/${payload}`,
                payload,
                config
            );

            return data;
        } catch (error) {
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);

export const addRatingAction = createAsyncThunk(
    "add-rating",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const { token } = JSON.parse(localStorage.getItem("user-auth"));

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.put(
                `${baseUrl}/product/rating`,
                {
                    newRating: payload.newRating,
                    productId: payload.id,
                },
                config
            );
            return data;
        } catch (error) {
            if (!error?.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);
export const deleteProductAction = createAsyncThunk(
    "delete-product",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const { token } = JSON.parse(localStorage.getItem("user-auth"));

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.delete(
                `${baseUrl}/product/${payload}`,
                config
            );
            dispatch(redirectAction());
            return data;
        } catch (error) {
            if (!error?.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);

export const likeProductAction = createAsyncThunk(
    "product/like",
    async (payload, { rejectWithValue, getState, rejected }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.put(
                `${baseUrl}/product/like`,
                { id: payload },
                config
            );
            return data;
        } catch (error) {
            if (!error?.response) {
                return error;
            }

            return rejectWithValue(error?.response?.data);
        }
    }
);
export const unlikeProductAction = createAsyncThunk(
    "product/unlike",
    async (payload, { rejectWithValue, getState, rejected }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.put(
                `${baseUrl}/product/unUnlike`,
                { id: payload },
                config
            );
            return data;
        } catch (error) {
            if (!error?.response) {
                return error;
            }

            return rejectWithValue(error?.response?.data);
        }
    }
);

const productSlice = createSlice({
    name: "Product",
    initialState: {},
    extraReducers: (builder) => {
        builder.addCase(addProductAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(addProductAction.fulfilled, (state, action) => {
            state.loading = false;
            state.NewProduct = action?.meta?.arg;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(addProductAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(fetchProductsAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(fetchProductsAction.fulfilled, (state, action) => {
            state.loading = false;
            state.products = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(fetchProductsAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(
            fetchProductByCategoryAction.pending,
            (state, action) => {
                state.loading = true;
                state.appErr = undefined;
                state.serverErr = undefined;
            }
        );
        builder.addCase(
            fetchProductByCategoryAction.fulfilled,
            (state, action) => {
                state.loading = false;
                state.products = action?.payload;
                state.appErr = undefined;
                state.serverErr = undefined;
            }
        );
        builder.addCase(
            fetchProductByCategoryAction.rejected,
            (state, action) => {
                state.loading = false;
                state.appErr = action?.payload?.message;
                state.serverErr = action?.error?.message;
            }
        );
        // builder.addCase(getProductDetailsAction.pending, (state, action) => {
        //     state.loading = true;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(getProductDetailsAction.fulfilled, (state, action) => {
        //     state.loading = false;
        //     state.productDetails = action?.payload;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(getProductDetailsAction.rejected, (state, action) => {
        //     state.loading = false;
        //     state.appErr = action?.payload?.message;
        //     state.serverErr = action?.error?.message;
        // });
        builder.addCase(getProductDetailsAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(getProductDetailsAction.fulfilled, (state, action) => {
            state.loading = false;
            state.productViewed = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(getProductDetailsAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(addRatingAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(addRatingAction.fulfilled, (state, action) => {
            state.loading = false;
            state.rating = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(addRatingAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(deleteProductAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(redirectAction, (state, action) => {
            state.productDeleted = true;
        });
        builder.addCase(deleteProductAction.fulfilled, (state, action) => {
            state.loading = false;
            state.productDeleted = false;
            state.productDetails = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(deleteProductAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(likeProductAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(likeProductAction.fulfilled, (state, action) => {
            state.loading = false;
            state.productliked = false;
            state.productDetails = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(likeProductAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(unlikeProductAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(unlikeProductAction.fulfilled, (state, action) => {
            state.loading = false;
            state.productunliked = false;
            state.productDetails = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(unlikeProductAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
    },
});

export default productSlice.reducer;
