import React from "react";
import {Link} from "react-router-dom";
import Moment from "react-moment";
import Preloader from "../../../../src/components/preloader/Preloader";

const PostCardTwo = ({post}) => {
    if (!post) {
        return <Preloader />;
    }

    return (
        <div className="cards">
            <Link to={`/posts/${post.slug}`}>
                <p className="cards-title-3 pb-2">{post.title}</p>
                <p className="cards-content-text pb-2">
                    {post.content.htmlToText().slice(0, 150)}
                    <span>...</span>
                </p>
                <p className="cards-content-text-time">
                    <Moment locale="bn" to={post.published_at} />
                </p>
            </Link>
        </div>
    );
};

export default PostCardTwo;
