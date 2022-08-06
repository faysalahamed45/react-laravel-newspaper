import {configureStore} from "@reduxjs/toolkit";
import React from "react";
import postReducer from "../features/posts/PostSlice";
import suspenseReducer from "../features/SuspenseSlice";
import filterPostsReducer from "../features/posts/filterPostsSlice";
import loggerMiddleware from "./loggerMiddleware";

const store = configureStore({
    reducer: {
        posts: postReducer,
        test_suspense: suspenseReducer,
        filter_posts: filterPostsReducer,
    },
    middleware: getDefaultMiddleware => getDefaultMiddleware().concat(loggerMiddleware),
});

export default store;
