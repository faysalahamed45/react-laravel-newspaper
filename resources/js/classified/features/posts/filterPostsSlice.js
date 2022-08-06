import {createAsyncThunk, createSlice} from "@reduxjs/toolkit";
import httpClient from "@classified/core/axios";

export const getFilterPosts = createAsyncThunk("filter-posts/getFilterPosts", async data => {
    const {_, ...params} = data;
    const response = await httpClient.get(`/filter-post`, {params});

    return response.data;
});

const filterPostsSlice = createSlice({
    name: "filter-posts",
    initialState: {
        message: "",
        status: "loading",
        data: [],
        errors: [],
        errorsMessage: "",
    },
    extraReducers: builder => {
        builder.addCase(getFilterPosts.pending, state => {
            state.status = "loading";
        });
        builder.addCase(getFilterPosts.fulfilled, (state, action) => {
            state.status = "success";
            state.data = action.payload.data;
            state.error = null;
        });
        builder.addCase(getFilterPosts.rejected, (state, action) => {
            state.status = "failed";
            state.data = [];
            state.error = action.error.message;
        });
    },
});

export default filterPostsSlice.reducer;
