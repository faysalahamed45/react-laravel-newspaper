import axios from "axios";

const { createSlice, createAsyncThunk } = require("@reduxjs/toolkit");

export const fetchHomePost = createAsyncThunk("homePost/fetchHomePost", async (path) => {
    const res = await axios.get(
        `http://thikana.oshnisoft.com/api/home-post`
    );
    return res.data.data;
});
const homePostslice = createSlice({
    name: "homePost",
    initialState: {
        isLoading: false,
        homePost: [],
        feature_post: [],
        feature_post_2: [],
        latest_post: [],
        exclusive: [],
        calcitr: [],
        amerika: [],
        links: [],
        category: [],
        error: null,
    },
    extraReducers: (builder) => {
        builder.addCase(fetchHomePost.pending, (state) => {
            state.isLoading = true;
        });
        builder.addCase(fetchHomePost.fulfilled, (state, action) => {
            state.isLoading = true;
            state.homePost = action.payload;
            state.feature_post = action.payload.feature_post;
            state.feature_post_2 = action.payload.feature_post_2;
            state.latest_post = action.payload.latest_post;
            state.top_read = action.payload.top_read;
            state.exclusive = action.payload.exclusive;
            state.calcitr = action.payload.calcitr;
            state.amerika = action.payload.amerika;
            // state.posts = action.payload.data.posts.data;
            // state.links = action.payload.data.posts.links;
            // state.category = action.payload.data.category;
            state.error = null;
        });
        builder.addCase(fetchHomePost.rejected, (state, action) => {
            state.isLoading = false;
            state.posts = [];
            state.error = action.error.message;
        });
    },
});
export default homePostslice.reducer;
