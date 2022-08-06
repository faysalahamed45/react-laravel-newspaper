import {configureStore} from "@reduxjs/toolkit";
import menuReducer from "../features/menu/menuSlice";
import postReducer from "../features/posts/postSlice";
import propsReducer from "../features/storeProps/propsSlice";
import PostDetailsReducer from "../features/posts/PostDetailsSlice";
import homePostsReducer from "../features/homePosts/homePostslice";
import homePostDetailReducer from "../features/homePostDetail/homePostDetailSlice";

const store = configureStore({
    reducer: {
        menu: menuReducer,
        posts: postReducer,
        postDetails: PostDetailsReducer,
        props: propsReducer,
        homePost: homePostsReducer,
        homePostDetail: homePostDetailReducer,
    },
});

export default store;
