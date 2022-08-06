import React from "react";
import {Link} from "react-router-dom";
import Moment from "react-moment";
import Preloader from "../../../../src/components/preloader/Preloader";

const PosCardFour = ({post}) => {
    if (!post) {
        return <Preloader />;
    }

    return (
        <div className="cards">
            <Link to={`/posts/${post.slug}`}>
                <div className="second-card-container">
                    <p className="cards-title-3 card-hd-font-size mb-2">{post.title}</p>
                    <p className="cards-content-text-time">
                        <Moment locale="bn" to={post.published_at} />
                    </p>
                </div>
            </Link>
        </div>
    );
};

export default PosCardFour;
