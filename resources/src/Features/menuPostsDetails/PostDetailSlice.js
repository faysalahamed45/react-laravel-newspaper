import axios from "axios";

const { createSlice, createAsyncThunk } = require("@reduxjs/toolkit");

export const fetchPostDetail = createAsyncThunk("PostDetail/fetchPostDetail", async (path) => {
    const res = await axios.get(
        `http://thikana.oshnisoft.com/api/post/${path}`
    );
    return res.data;
});
const PostDetailSlice = createSlice({
    name: "PostDetail",
    initialState: {
        isLoading: false,
        postsDetail: [],
        links: [],
        category: [],
        error: null,
    },
    extraReducers: (builder) => {
        builder.addCase(fetchPostDetail.pending, (state) => {
            state.isLoading = true;
        });
        builder.addCase(fetchPostDetail.fulfilled, (state, action) => {
            state.isLoading = true;
            state.postsDetail = action.payload.data;
            // state.posts = action.payload.data.posts.data;
            // state.links = action.payload.data.posts.links;
            // state.category = action.payload.data.category;
            state.error = null;
        });
        builder.addCase(fetchPostDetail.rejected, (state, action) => {
            state.isLoading = false;
            state.posts = [];
            state.error = action.error.message;
        });
    },
});
export default PostDetailSlice.reducer;
