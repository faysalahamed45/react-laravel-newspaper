import {memo, useEffect} from "react";
import Navbar from "./Navbar";
import {useDispatch} from "react-redux";
import {fetchMenu} from "../../features/menu/menuSlice";

const Header = () => {
    const dispatch = useDispatch();

    useEffect(() => {
        console.log("Header Component Mounted.");
        dispatch(fetchMenu());
    }, []);

    return <Navbar />;
};

export default memo(Header);
