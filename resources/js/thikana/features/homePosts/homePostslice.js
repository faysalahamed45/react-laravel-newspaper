import httpClient from "../../core/axios";

const {createSlice, createAsyncThunk} = require("@reduxjs/toolkit");

export const fetchHomePost = createAsyncThunk("homePost/fetchHomePost", async path => {
    const res = await httpClient.get("/home-post");

    return res.data.data;
});

const homePostSlice = createSlice({
    name: "homePost",
    initialState: {
        isLoading: false,
        homePost: [],
        feature_post: [],
        feature_post_2: [],
        latest_post: [],
        exclusive: [],
        category_section_1: null,
        category_section_2: null,
        category_section_3: null,
        category_section_4: null,
        category_section_5: null,
        category_section_6: null,
        category_section_7: null,
        category_section_8: null,
        category_section_9: null,
        links: [],
        category: [],
        error: null,
    },
    extraReducers: builder => {
        builder.addCase(fetchHomePost.pending, state => {
            state.isLoading = true;
        });
        builder.addCase(fetchHomePost.fulfilled, (state, action) => {
            state.isLoading = true;
            state.error = null;
            state.homePost = action.payload;
            state.feature_post = action.payload.feature_post;
            state.feature_post_2 = action.payload.feature_post_2;
            state.latest_post = action.payload.latest_post;
            state.top_read = action.payload.top_read;
            state.exclusive = action.payload.exclusive;
            state.category_section_1 = action.payload.category_section_1;
            state.category_section_2 = action.payload.category_section_2;
            state.category_section_3 = action.payload.category_section_3;
            state.category_section_4 = action.payload.category_section_4;
            state.category_section_5 = action.payload.category_section_5;
            state.category_section_6 = action.payload.category_section_6;
            state.category_section_7 = action.payload.category_section_7;
            state.category_section_8 = action.payload.category_section_8;
            state.category_section_9 = action.payload.category_section_9;
        });
        builder.addCase(fetchHomePost.rejected, (state, action) => {
            state.isLoading = false;
            state.posts = [];
            state.error = action.error.message;
        });
    },
});
export default homePostSlice.reducer;
