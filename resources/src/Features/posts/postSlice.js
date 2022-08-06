import axios from "axios";

const { createSlice, createAsyncThunk } = require("@reduxjs/toolkit");

export const fetchPost = createAsyncThunk("posts/fetchPost", async (path) => {  
    const res = await axios.get(
        `http://thikana.oshnisoft.com/api/menu-post${path}`
    );
    return res.data;
});
const postSlice = createSlice({
    name: "posts",
    initialState: {
        isLoading: false,
        posts: [],
        links: [],
        category: [],
        error: null,
    },
    extraReducers: (builder) => {
        builder.addCase(fetchPost.pending, (state) => {
            state.isLoading = true;
        });
        builder.addCase(fetchPost.fulfilled, (state, action) => {
            state.isLoading = true;
            state.posts = action.payload.data.posts.data;
            state.links = action.payload.data.posts.links;
            state.category = action.payload.data.category;
            state.error = null;
        });
        builder.addCase(fetchPost.rejected, (state, action) => {
            state.isLoading = false;
            state.posts = [];
            state.error = action.error.message;
        });
    },
});
export default postSlice.reducer;
