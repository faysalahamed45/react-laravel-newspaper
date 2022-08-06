import React from "react";
import {Link} from "react-router-dom";
import app from "../../config/app";
import Preloader from "../../../../src/components/preloader/Preloader";

const NumberedPostCard = ({post, number}) => {
    if (!post) {
        return <Preloader />;
    }

    return (
        <Link to={`/posts/${post.slug}`} className="text-decoration-none">
            <div className="number-flex">
                <p className="fourth-card-number">{parseInt(number).toLocaleString(app.locale)}</p>
                <p className="cards-title-4 ps-xxl-0 ps-xl-0 ps-md-0 ps-sm-2 ps-3">{post.title}</p>
            </div>
        </Link>
    );
};

export default NumberedPostCard;
