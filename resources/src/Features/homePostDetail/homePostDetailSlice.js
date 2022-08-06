import axios from "axios";

const { createSlice, createAsyncThunk } = require("@reduxjs/toolkit");

export const fetchHomePostDetail = createAsyncThunk("homePostDetail/fetchHomePostDetail", async (path) => {
    const res = await axios.get(
			`http://thikana.oshnisoft.com/api/post/${path}`
    );
    return res.data.data;
});
const homePostDetailSlice = createSlice({
    name: "homePostDetail",
    initialState: {
        isLoading: false,
        homePostDetail: [],
        // feature_post: [],
        // feature_post_2: [],
        // latest_post: [],
        // exclusive: [],
        // calcitr: [],
        // amerika: [],
        // links: [],
        // category: [],
        error: null,
    },
    extraReducers: (builder) => {
        builder.addCase(fetchHomePostDetail.pending, (state) => {
            state.isLoading = true;
        });
        builder.addCase(fetchHomePostDetail.fulfilled, (state, action) => {
            state.isLoading = true;
            state.homePostDetail = action.payload;
            // state.feature_post = action.payload.feature_post;
            // state.feature_post_2 = action.payload.feature_post_2;
            // state.latest_post = action.payload.latest_post;
            // state.top_read = action.payload.top_read;
            // state.exclusive = action.payload.exclusive;
            // state.calcitr = action.payload.calcitr;
            // state.amerika = action.payload.amerika;
            // state.posts = action.payload.data.posts.data;
            // state.links = action.payload.data.posts.links;
            // state.category = action.payload.data.category;
            state.error = null;
        });
        builder.addCase(fetchHomePostDetail.rejected, (state, action) => {
            state.isLoading = false;
            state.posts = [];
            state.error = action.error.message;
        });
    },
});
export default homePostDetailSlice.reducer;
