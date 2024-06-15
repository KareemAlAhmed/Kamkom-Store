import { createSlice, createAsyncThunk, createAction } from "@reduxjs/toolkit";
import axios from "axios";
import baseUrl from "../../utils/baseUrl";

const isRegistered = createAction("registered");

export const userRegisterAction = createAsyncThunk(
    "user/register",
    async (paylaod, { rejectWithValue, getState, dispatch }) => {
        const config = {
            headers: {
                "Content-Type": "application/json",
            },
        };
        try {
            console.log("the payload is " , paylaod);
            const { data } = await axios.post(`${baseUrl}/register`, paylaod).then(res => console.log(res)).catch(err=>console.log(err));
            dispatch(isRegistered());
            return data;
        } catch (error) {
            console.log(error)
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error.response.data);
        }
    }
);
export const userLoginAction = createAsyncThunk(
    "user/login",
    async (paylaod, { rejectWithValue, getState, dispatch }) => {
        const loginData = {
            email: paylaod?.email,
            password: paylaod?.password,
        };

        const config = {
            headers: {
                "Content-Type": "application/json",
            },
        };

        try {
            const { data } = await axios.post(
                `${baseUrl}/login`,
                loginData,
                config
            );
            localStorage.setItem("user-auth", JSON.stringify(data));
            return data;
        } catch (error) {
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error.response.data);
        }
    }
);

export const userLogoutAction = createAsyncThunk(
    "user/logout",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        try {
            localStorage.removeItem("user-auth");
        } catch (error) {
            if (!error.response) {
                return error;
            }
            return rejectWithValue(error?.response?.data);
        }
    }
);
export const fetchProfileDetailsCtrl = createAsyncThunk(
    "user/profile",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.get(
                `${baseUrl}/users/details/${payload}`,
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
export const userdetailsAction = createAsyncThunk(
    "user/login-details",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.get(
                `${baseUrl}/users/login-user`,
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

export const updateProfileAction = createAsyncThunk(
    "update/profile",
    async (payload, { rejectWithValue, getState, dispatch }) => {
        const token = JSON.parse(localStorage.getItem("user-auth")).token;

        const config = {
            headers: {
                Authorization: `bearer ${token}`,
            },
        };

        try {
            const { data } = await axios.put(
                `${baseUrl}/users/update-profile`,
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

// export const followUserAction = createAsyncThunk(
//     "follow/user",
//     async (payload, { rejectWithValue, getState, rejected }) => {
//         const token = JSON.parse(localStorage.getItem("user-auth")).token;

//         const config = {
//             headers: {
//                 Authorization: `bearer ${token}`,
//             },
//         };

//         try {
//             const { data } = await axios.put(
//                 `${baseUrl}/users/follow`,
//                 { id: payload },
//                 config
//             );
//             return data;
//         } catch (error) {
//             if (!error?.response) {
//                 return error;
//             }

//             return rejectWithValue(error?.response?.data);
//         }
//     }
// );

// export const unFollowUserAction = createAsyncThunk(
//     "unfollow/user",
//     async (payload, { rejectWithValue, getState, rejected }) => {
//         const token = JSON.parse(localStorage.getItem("user-auth")).token;

//         const config = {
//             headers: {
//                 Authorization: `bearer ${token}`,
//             },
//         };

//         try {
//             const { data } = await axios.put(
//                 `${baseUrl}/users/unfollow`,
//                 { id: payload },
//                 config
//             );
//             return data;
//         } catch (error) {
//             if (!error?.response) {
//                 return error;
//             }

//             return rejectWithValue(error?.response?.data);
//         }
//     }
// );

// export const blockUserAction = createAsyncThunk(
//     "block/user",
//     async (payload, { rejectWithValue, getState, rejected }) => {
//         const token = JSON.parse(localStorage.getItem("user-auth")).token;

//         const config = {
//             headers: {
//                 Authorization: `bearer ${token}`,
//             },
//         };

//         try {
//             const { data } = await axios.put(
//                 `${baseUrl}/users/block-user`,
//                 { id: payload },
//                 config
//             );
//             return data;
//         } catch (error) {
//             if (!error?.response) {
//                 return error;
//             }

//             return rejectWithValue(error?.response?.data);
//         }
//     }
// );

// export const unBlockUserAction = createAsyncThunk(
//     "inblock/user",
//     async (payload, { rejectWithValue, getState, rejected }) => {
//         const token = JSON.parse(localStorage.getItem("user-auth")).token;

//         const config = {
//             headers: {
//                 Authorization: `bearer ${token}`,
//             },
//         };

//         try {
//             const { data } = await axios.put(
//                 `${baseUrl}/users/unblock-user`,
//                 { id: payload },
//                 config
//             );
//             return data;
//         } catch (error) {
//             if (!error?.response) {
//                 return error;
//             }

//             return rejectWithValue(error?.response?.data);
//         }
//     }
// );

// export const UploadProfileImgAction = createAsyncThunk(
//     "upload/profile-image",
//     async (payload, { rejectWithValue, getState, rejected }) => {
//         const token = JSON.parse(localStorage.getItem("user-auth")).token;

//         const config = {
//             headers: {
//                 Authorization: `bearer ${token}`,
//             },
//         };

//         const formData = new FormData();
//         formData.append("image", payload?.image);

//         try {
//             const { data } = await axios.put(
//                 `${baseUrl}/users/uploadProfile-img`,
//                 formData,
//                 config
//             );
//             return data;
//         } catch (error) {
//             if (!error?.response) {
//                 return error;
//             }

//             return rejectWithValue(error?.response?.data);
//         }
//     }
// );

// export const fetchAllUsersAction = createAsyncThunk(
//     "fetch/user",
//     async (payload, { rejectWithValue, getState, rejected }) => {
//         const token = JSON.parse(localStorage.getItem("user-auth")).token;

//         const config = {
//             headers: {
//                 Authorization: `bearer ${token}`,
//             },
//         };

//         try {
//             const { data } = await axios.get(
//                 `${baseUrl}/users/fetch-users`,
//                 config
//             );
//             return data;
//         } catch (error) {
//             if (!error?.response) {
//                 return error;
//             }

//             return rejectWithValue(error?.response?.data);
//         }
//     }
// );

const userSlice = createSlice({
    name: "user",
    initialState: {},
    extraReducers: (builder) => {
        builder.addCase(userRegisterAction.pending, (state, action) => {
            state.loading = true;
            state.userRegister = undefined;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(isRegistered, (state, action) => {
            state.isRegister = true;
        });
        builder.addCase(userRegisterAction.fulfilled, (state, action) => {
            state.loading = false;
            state.isRegister = false;
            state.userRegister = action.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(userRegisterAction.rejected, (state, action) => {
            state.loading = false;
            state.appErrRegister = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(userLoginAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(userLoginAction.fulfilled, (state, action) => {
            state.loading = false;
            state.userAuth = action.payload;
            state.Logout = false;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(userLoginAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(userLogoutAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(userLogoutAction.fulfilled, (state, action) => {
            state.loading = false;
            state.Logout = true;
            state.userAuth = undefined;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(userLogoutAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(fetchProfileDetailsCtrl.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(fetchProfileDetailsCtrl.fulfilled, (state, action) => {
            state.loading = false;
            state.profileUser = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(fetchProfileDetailsCtrl.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        // builder.addCase(followUserAction.pending, (state, action) => {
        //     state.loading = true;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(followUserAction.fulfilled, (state, action) => {
        //     state.loading = false;
        //     state.followUser = action?.payload;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(followUserAction.rejected, (state, action) => {
        //     state.loading = false;
        //     state.appErr = action?.payload?.message;
        //     state.serverErr = action?.error?.message;
        // });
        // builder.addCase(unFollowUserAction.pending, (state, action) => {
        //     state.loading = true;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(unFollowUserAction.fulfilled, (state, action) => {
        //     state.loading = false;
        //     state.unFollowUser = action?.payload;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(unFollowUserAction.rejected, (state, action) => {
        //     state.loading = false;
        //     state.appErr = action?.payload?.message;
        //     state.serverErr = action?.error?.message;
        // });
        // builder.addCase(blockUserAction.pending, (state, action) => {
        //     state.loading = true;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(blockUserAction.fulfilled, (state, action) => {
        //     state.loading = false;
        //     state.blockUser = action?.payload;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(blockUserAction.rejected, (state, action) => {
        //     state.loading = false;
        //     state.appErr = action?.payload?.message;
        //     state.serverErr = action?.error?.message;
        // });
        // builder.addCase(unBlockUserAction.pending, (state, action) => {
        //     state.loading = true;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(unBlockUserAction.fulfilled, (state, action) => {
        //     state.loading = false;
        //     state.unBlockUser = action?.payload;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(unBlockUserAction.rejected, (state, action) => {
        //     state.loading = false;
        //     state.appErr = action?.payload?.message;
        //     state.serverErr = action?.error?.message;
        // });
        builder.addCase(userdetailsAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(userdetailsAction.fulfilled, (state, action) => {
            state.loading = false;
            state.userLoginDetails = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(userdetailsAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        builder.addCase(updateProfileAction.pending, (state, action) => {
            state.loading = true;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(updateProfileAction.fulfilled, (state, action) => {
            state.loading = false;
            state.updatedProfile = action?.payload;
            state.appErr = undefined;
            state.serverErr = undefined;
        });
        builder.addCase(updateProfileAction.rejected, (state, action) => {
            state.loading = false;
            state.appErr = action?.payload?.message;
            state.serverErr = action?.error?.message;
        });
        // builder.addCase(UploadProfileImgAction.pending, (state, action) => {
        //     state.loading = true;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(UploadProfileImgAction.fulfilled, (state, action) => {
        //     state.loading = false;
        //     state.imgUploaded = action?.payload;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(UploadProfileImgAction.rejected, (state, action) => {
        //     state.loading = false;
        //     state.appErr = action?.payload?.message;
        //     state.serverErr = action?.error?.message;
        // });
        // builder.addCase(fetchAllUsersAction.pending, (state, action) => {
        //     state.loading = true;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(fetchAllUsersAction.fulfilled, (state, action) => {
        //     state.loading = false;
        //     state.usersToAuth = action?.payload;
        //     state.appErr = undefined;
        //     state.serverErr = undefined;
        // });
        // builder.addCase(fetchAllUsersAction.rejected, (state, action) => {
        //     state.loading = false;
        //     state.appErr = action?.payload?.message;
        //     state.serverErr = action?.error?.message;
        // });
    },
});

export default userSlice.reducer;
