import React, {Suspense} from "react";
import {Route, Routes as RouterRoutes} from "react-router-dom";
import Preloader from "../../src/components/preloader/Preloader";

const files = require.context("./pages", true, /\.js$/i);
const routes = files.keys().map(key => {
    const arr = key.split("/");
    arr.shift();
    const path =
        "/" +
        arr
            .map(i => i.replace(/\[(.+)]/, ":$1"))
            .join("/")
            .replace(/index|\.js$/g, "")
            .replace(/\[\.{3}.+]/, "*")
            .toLowerCase();

    // const element = lazy(() => import(key));
    // return {path, element};

    return {path, element: files(key).default};
});

const Routes = () => {
    return (
        <Suspense fallback={<Preloader />}>
            <RouterRoutes>
                {routes.map(item => (
                    <Route key={item.path} path={item.path} element={<item.element />} />
                ))}
            </RouterRoutes>
        </Suspense>
    );
};

export default Routes;
