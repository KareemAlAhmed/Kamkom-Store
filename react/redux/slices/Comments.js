import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import baseUrl from "../../../utlis/baseUrl";
import axios from "axios";

export const addComment = createAsyncThunk(
    "add/comment",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.post(
                `${baseUrl}/comments/create`,
                {
                    description: payload.description,
                    userId: payload.userId,
                    post: payload.post,
                },
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

export const editComment = createAsyncThunk(
    "edit/comment",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.put(
                `${baseUrl}/comments/update/${payload.id}`,
                {
                    description: payload.description,
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
export const deleteComment = createAsyncThunk(
    "delete/comment",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.delete(
                `${baseUrl}/comments/delete/${payload}`,
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

const commentSlice = createSlice({
    name: "comment",
    initialState: {},
    extraReducers: (builder) => {
        builder.addCase(addComment.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(addComment.fulfilled, (state, action) => {
            state.loading = false;
            state.newComment = action.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(addComment.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action.payload.message;
            state.serverErr = action.error.message;
        });
        builder.addCase(editComment.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(editComment.fulfilled, (state, action) => {
            state.loading = false;
            state.editComment = action.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(editComment.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action.payload.message;
            state.serverErr = action.error.message;
        });
        builder.addCase(deleteComment.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(deleteComment.fulfilled, (state, action) => {
            state.loading = false;
            state.deleteComment = action.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(deleteComment.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action.payload.message;
            state.serverErr = action.error.message;
        });
    },
});

export default commentSlice.reducer;
