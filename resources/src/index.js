import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import { BrowserRouter } from "react-router-dom";
import reportWebVitals from './reportWebVitals';
import { Provider } from 'react-redux';
// import store from "./App/store";
import { configureStore } from '@reduxjs/toolkit';
import menuReducer from './Features/menu/menuSlice';
import postReducer from './Features/posts/postSlice';
import propsReducer from './Features/storeProps/propsSlice';
import PostDetailReducer from './Features/menuPostsDetails/PostDetailSlice';
import homePostsReducer from './Features/homePosts/homePostslice';
import homePostDetailReducer from './Features/homePostDetail/homePostDetailSlice';

const store = configureStore({
 reducer:{
  menu:menuReducer,
  posts:postReducer,
  postDetail:PostDetailReducer,
  props:propsReducer,
	homePost:homePostsReducer,
	homePostDetail:homePostDetailReducer
 }
})

// export default store;
const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <Provider store={store}>
  <BrowserRouter>
    <App />
  </BrowserRouter>
</Provider>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
