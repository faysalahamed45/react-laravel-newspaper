import axios from "axios";

const { createSlice, createAsyncThunk } = require("@reduxjs/toolkit");

export const fetchMenu = createAsyncThunk("menu/fetchMenu",async()=>{
  const res = await axios.get("http://thikana.oshnisoft.com/api/menu");
  return res.data.data
})
const menuSlice = createSlice({
  name : "menu",
  initialState :{
    isLoading:false,
    posts:[],
    footer:[],
    header:[],
    hamburger:[],
    error:null
  },
  extraReducers:(builder)=>{
    builder.addCase(fetchMenu.pending,(state)=>{
      state.isLoading = true;
    });
    builder.addCase(fetchMenu.fulfilled,(state,action)=>{
      state.isLoading = false;
      state.posts = action.payload;
      state.footer = action.payload.footer;
      state.header = action.payload.header;
      state.hamburger = action.payload.hamburger;
      state.error = null
    });
    builder.addCase(fetchMenu.rejected,(state,action)=>{
      state.isLoading = false;
      state.posts = [];
      state.error =action.error.message;
    })
  }
})
export default menuSlice.reducer;