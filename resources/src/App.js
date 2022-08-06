import React, { memo, Suspense, lazy, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Routes, Route, Link, useLocation, Navigate } from "react-router-dom";
import { fetchMenu } from "./Features/menu/menuSlice";
import Preloader from "./components/preloader/Preloader";
import MenuPosts from "./pages/MenuPosts";
import SecondPostDetail from "./components/PostDetails/SecondPostDetail";
import PostContentDetail from "./components/PostDetails/PostContentDetail";
import { fetchPost } from "./Features/posts/postSlice";
import { fetchHomePost } from "./Features/homePosts/homePostslice";
import HomeDisplayContent from "./components/Home/HomeDisplayContent/HomeDisplayContent";
const Home = lazy(() => import("./pages/Home"));

const App = () => {
    const location = useLocation();
    const path = location.path;
    // const pathSlice = path?.slice(1);
    const { header, footer, hamburger } = useSelector((state) => state.menu);
    const { posts } = useSelector((state) => state.posts);
    // const { feature_post, latest_post, feature_post_2, exclusive } =
    //     useSelector((state) => state.homePost);
	const {homePost,feature_post, feature_post_2,exclusive,latest_post,amerika} = useSelector(
					(state) => state.homePost)
    const dispatch = useDispatch();
    useEffect(() => {
        dispatch(fetchMenu());
        // dispatch(fetchHomePost());
    }, []);
		useEffect(() => {
			// dispatch(fetchMenu());
			dispatch(fetchHomePost());
	}, [path]);

    useEffect(() => {
        dispatch(
            fetchPost(`/${location?.state?.description?.category?.name_en}`)
        );
    }, []);
    console.log(homePost);
    return (
        <div>
            {/* <PostViews/> */}
            <Suspense fallback={<Preloader />}>
                <Routes>
                    <Route path="/" element={<Navigate to="/home" />} />
                    <Route path="/home" element={<Home />} />
                    {header?.map((route) => {
                        return route.slug_bn === "Prbas" ||
                            route.slug_bn === "Amerika" ? (
                            <Route
                                key={route.id}
                                path={`/${route.slug_bn}`}
                                element={<MenuPosts />}
                            />
                        ) : (
                            <Route
                                key={route.id}
                                path={`/${route.slug_bn}`}
                                element={<MenuPosts />}
                            />
                        );
                    })}
                    {hamburger?.map((route) => {
                        return route.slug_bn === "Prbas" ||
                            route.slug_bn === "Amerika" ? (
                            <Route
                                key={route.id}
                                path={`/${route.slug_bn}`}
                                element={<MenuPosts />}
                            />
                        ) : (
                            <Route
                                key={route.id}
                                path={`/${route.slug_bn}`}
                                element={<MenuPosts />}
                            />
                        );
                    })}
                    {footer?.map((route) => {
                        return route.slug_bn === "Prbas" ||
                            route.slug_bn === "Amerika" ? (
                            <Route
                                key={route.id}
                                path={`/${route.slug_bn}`}
                                element={<MenuPosts />}
                            />
                        ) : (
                            <Route
                                key={route.id}
                                path={`/${route.slug_bn}`}
                                element={<MenuPosts />}
                            />
                        );
                    })}
                    {posts?.map((menuPost) => {
                        return (
                            <Route
                                key={menuPost.id}
                                path={`/${menuPost?.slug_bn}`}
                                element={<PostContentDetail />}
                            />
                        );
                    })}

                    {feature_post?.map((homePostDetail) => {
                        return (
                            <Route
                                key={homePostDetail.id}
                                path={`/${homePostDetail?.slug_bn}`}
                                element={<HomeDisplayContent />}
                            />
                        );
                    })}

                    {feature_post_2?.map((homePostDetail) => {
                        return (
                            <Route
                                key={homePostDetail.id}
                                path={`/${homePostDetail?.slug_bn}`}
                                element={<HomeDisplayContent />}
                            />
                        );
                    })}

                    {latest_post?.map((homePostDetail) => {
                        return (
                            <Route
                                key={homePostDetail.id}
                                path={`/${homePostDetail?.slug_bn}`}
                                element={<HomeDisplayContent />}
                            />
                        );
                    })}
                    {exclusive?.map((homePostDetail) => {
                        return (
                            <Route
                                key={homePostDetail.id}
                                path={`/${homePostDetail?.slug_bn}`}
                                element={<HomeDisplayContent />}
                            />
                        );
                    })}
                    {amerika?.map((homePostDetail) => {
                        return (
                            <Route
                                key={homePostDetail.id}
                                path={`/${homePostDetail?.slug_bn}`}
                                element={<HomeDisplayContent />}
                            />
                        );
                    })}
                </Routes>
            </Suspense>
        </div>
    );
};

export default memo(App);
