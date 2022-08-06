import React, {memo} from "react";
import {Provider} from "react-redux";
import store from "./store";
import Routes from "./routes";
import Layout from "./components/layout";

const App = () => {
    // useEffect(() => {
    //     dispatch(
    //         fetchPost(`/${location?.state?.description?.category?.name_en}`)
    //     );
    // }, []);
    return (
        <Provider store={store}>
            <Layout>
                <Routes/>
            </Layout>
        </Provider>
    );
};

export default memo(App);
