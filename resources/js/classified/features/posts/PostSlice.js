import {createAsyncThunk, createSlice} from "@reduxjs/toolkit";
import httpClient from "@classified/core/axios";

export const getPosts = createAsyncThunk("posts/getPosts", async () => {
    const response = await httpClient.get("/home-post");

    return response.data;
});

const postSlice = createSlice({
    name: "posts",
    initialState: {
        message: "",
        status: "loading",
        // data: useTranslation({data: posts, lang: app.locale}),
        data: [],
        errors: [],
        errorsMessage: "",
    },
    extraReducers: builder => {
        builder.addCase(getPosts.pending, state => {
            state.status = "loading";
        });
        builder.addCase(getPosts.fulfilled, (state, action) => {
            state.status = "success";
            state.data = action.payload.data;
            state.error = null;
        });
        builder.addCase(getPosts.rejected, (state, action) => {
            state.status = "failed";
            state.data = [];
            state.error = action.error.message;
        });
    },
});

export default postSlice.reducer;
