import { configureStore } from '@reduxjs/toolkit';
import React from 'react';
import menuReducer from '../Features/menu/menuSlice';
import postReducer from '../Features/posts/postSlice';

const store = configureStore({
  reducer:{
   menu:menuReducer,
   posts:postReducer
  }
})

export default store;