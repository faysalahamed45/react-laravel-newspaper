import {useEffect} from "react";
import {useParams} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import Spinner from "../../components/Spinner";
import {getFilterPosts} from "../../features/posts/filterPostsSlice";
import HighlightedPost from "../../components/posts/HighlightedPost";

export default function Filter() {
    const params = useParams();
    const dispatch = useDispatch();
    const {status, data: posts} = useSelector(state => state.filter_posts);

    useEffect(() => {
        dispatch(getFilterPosts({filter: params.filter}));
    }, [params.filter]);

    if (status === "loading") {
        return <Spinner spinner={true} />;
    }

    // if (params.filter === "premium") {
    //     console.log(posts);
    // }

    return (
        <div className="col-12">
            <div className="row">
                <HighlightedPost posts={posts} />
            </div>
        </div>
    );
}
