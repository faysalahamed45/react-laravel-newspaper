import React, {lazy, Suspense} from "react";
import {Route, Routes} from "react-router-dom";
import Preloader from "../../src/components/preloader/Preloader";
const LoadingWithSuspense = lazy(() => import("./pages/LoadingWithSuspense"));
const About = lazy(() => import("./pages/About"));
const Home = lazy(() => import("./pages/Home"));
const Category = lazy(() => import("./pages/Category"));
const Filter = lazy(() => import("./pages/filters/[filter]"));

export default function routes() {
    return (
        <Suspense fallback={<Preloader />}>
            <Routes>
                <Route exact={true} path="/about" element={<About />} />
                {/*<Route exact={true} path="/profile" element={<Profile/>}/>*/}
                <Route exact={true} path="/suspense" element={<LoadingWithSuspense />} />
                <Route exact={true} path="/details/:id" element={<About />} />
                <Route exact={true} path="/filters/:filter" element={<Filter />} />
                <Route exact={true} path="/categories" element={<Category />} />
                <Route exact={true} name="categories.show" path="/categories/:category" element={<Category />} />
                <Route exact={true} path="/" element={<Home />} />
            </Routes>
        </Suspense>
    );
}
