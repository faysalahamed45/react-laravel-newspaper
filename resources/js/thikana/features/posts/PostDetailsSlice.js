const {createSlice, createAsyncThunk} = require("@reduxjs/toolkit");
import httpClient from "../../core/axios";

export const fetchPostDetails = createAsyncThunk("postDetails/fetchPostDetails", async path => {
    const res = await httpClient.get(`/post/${path}`);

    return res.data;
});

const PostDetailsSlice = createSlice({
    name: "postDetails",
    initialState: {
        isLoading: true,
        data: {},
        error: null,
    },
    extraReducers: builder => {
        builder.addCase(fetchPostDetails.pending, state => {
            state.isLoading = true;
        });
        builder.addCase(fetchPostDetails.fulfilled, (state, action) => {
            state.isLoading = false;
            state.error = null;
            state.data = action.payload.data;
        });
        builder.addCase(fetchPostDetails.rejected, (state, action) => {
            state.isLoading = false;
            state.posts = {};
            state.error = action.error.message;
        });
    },
});
export default PostDetailsSlice.reducer;
