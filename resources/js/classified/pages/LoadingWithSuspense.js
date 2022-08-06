import React, {Suspense, useEffect} from "react";
import {useDispatch, useSelector} from "react-redux";
import {fetchData} from "../features/SuspenseSlice";
import * as TYPES from "../store/types";

export default function LoadingWithSuspense() {
    return (
        <Suspense fallback={<h1>Loading profile...</h1>}>
            <ProfileDetails />
        </Suspense>
    );
}

function ProfileDetails() {
    const {data, status, error} = useSelector(state => state.test_suspense);
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(fetchData());
    }, []);
    console.log({status});

    if (status === TYPES.LOADING) {
        return <h1>Loading profile...</h1>;
    }

    return <h1>{data.name}</h1>;
}
