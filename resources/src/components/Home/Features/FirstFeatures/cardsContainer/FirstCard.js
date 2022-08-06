import React from "react";
import { Link } from "react-router-dom";
import MomentTo from "../../../../../MomentJs/MomentTo";

const FirstCard = ({ featuaresPost }) => {
    return (
        <>
            {featuaresPost?.slice(0, 1).map((postContent) => {
                return (
                    <div key={postContent.id} className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 order-xxl-0 order-xl-0 order-md-0 order-sm-1 order-1">
                        <div className="cards">
                            <Link to={`/${postContent?.slug_bn}`}>
                                <p className="cards-title-1 pb-2 pt-xxl-0 pt-xl-0 pt-md-0 pt-sm-3 pt-3">
                                    {postContent?.title_bn}
                                </p>
                                <p className="cards-content-text pb-2">
                                    {postContent?.content_bn.htmlToText().slice(0,150)}
                                    <span>...</span>
                                </p>
                                <p className="cards-content-text-time">
                                    <MomentTo
                                        date={postContent?.published_at}
                                    />
                                </p>
                            </Link>
                        </div>
                    </div>
                );
            })}
        </>
    );
};

export default FirstCard;
