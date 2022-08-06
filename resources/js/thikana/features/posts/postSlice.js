import {createAsyncThunk, createSlice} from "@reduxjs/toolkit";
import httpClient from "../../core/axios";

export const fetchPost = createAsyncThunk("posts/fetchPost", async data => {
    const {category, ...params} = data;
    const res = await httpClient.get(`/menu-post/${category}`, {params});

    return res.data;
});

const postSlice = createSlice({
    name: "posts",
    initialState: {
        isLoading: true,
        category: {},
        posts: [],
        pagination: {},
        error: null,
    },
    extraReducers: builder => {
        builder.addCase(fetchPost.pending, state => {
            state.isLoading = true;
        });
        builder.addCase(fetchPost.fulfilled, (state, action) => {
            state.isLoading = false;
            state.error = null;
            state.category = action.payload.data.category;
            const {data: posts, ...pagination} = action.payload.data.posts;
            if (state.pagination.path === pagination.path && state.pagination.current_page !== pagination.current_page) {
                state.posts = [...state.posts, ...posts];
            } else {
                state.posts = posts;
            }
            state.pagination = pagination;
        });
        builder.addCase(fetchPost.rejected, (state, action) => {
            state.isLoading = false;
            state.posts = [];
            state.error = action.error.message;
        });
    },
});

export default postSlice.reducer;
