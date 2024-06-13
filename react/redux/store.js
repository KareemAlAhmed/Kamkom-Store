import { configureStore } from "@reduxjs/toolkit";
import userSlice from "./slices/User";
import productSlice from "./slices/Product";

const store = configureStore({
    reducer: {
        user: userSlice,
        product: productSlice,
    },
});

export default store;
