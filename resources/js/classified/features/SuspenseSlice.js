import {createAsyncThunk, createEntityAdapter, createSlice} from "@reduxjs/toolkit";
import * as TYPES from "../store/types";

export function fetchUser() {
    return new Promise(resolve => {
        setTimeout(() => {
            console.log("fetched user");
            const data = {
                name: "Ferdous Anam",
            };
            resolve(data);
        }, 1000);
    });
}

export const fetchData = createAsyncThunk("test_suspense/fetchData", async (data, {getState}) => {
    // const {loading} = getState().test_suspense
    // if (loading !== 'idle') {
    //     return
    // }
    return await fetchUser();
});

const usersAdapter = createEntityAdapter();

const testSlice = createSlice({
    name: "test_suspense",
    initialState: usersAdapter.getInitialState({
        loading: "idle",
        status: TYPES.LOADING,
        data: {},
        error: null,
    }),
    reducers: {
        usersLoaded: usersAdapter.setAll,
        userDeleted: usersAdapter.removeOne,
    },
    extraReducers: builder => {
        builder.addCase(fetchData.pending, state => {
            state.status = TYPES.LOADING;
        });
        builder.addCase(fetchData.fulfilled, (state, action) => {
            state.status = TYPES.SUCCESS;
            state.data = action.payload;
        });
        builder.addCase(fetchData.rejected, (state, action) => {
            state.status = TYPES.ERROR;
        });
        builder.addCase("set_status", (state, action) => {
            state.status = action.payload;
        });
    },
});

export default testSlice.reducer;
