import axios from "axios";

const { createSlice} = require("@reduxjs/toolkit");


export const propsSlice = createSlice({
    name: "props",
    initialState: {
        props: [

				],
    },
 reducers:{
	 addProps:(state,action)=>{
		 state.props=[...state.props, action.payload.category];
	 }
 }
});
export const { addProps} = propsSlice.actions
export default propsSlice.reducer;
