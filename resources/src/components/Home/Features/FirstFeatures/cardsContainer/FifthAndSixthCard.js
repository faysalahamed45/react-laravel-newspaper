import React from "react";
import { Link } from "react-router-dom";
import MomentTo from "../../../../../MomentJs/MomentTo";

const FifthAndSixthCard = ({ featuaresPost }) => {
    return (
        <>
            {featuaresPost?.slice(3, 5).map((postContent) => {
                return (
                    <div key={postContent.id} className="col-xxl-4 col-xl-4 col-md-4 col-sm-12 col-12 thikana-2nd-content">
                        <hr className="d-xxl-none d-xl-none d-md-none d-sm-block d-block" />
                        <div className="cards">
                            <Link to={`/${postContent?.slug_bn}`}>
                                <p className="cards-title-3 pb-2">
                                    {postContent?.title_bn.slice(0, 50)}
                                </p>
                                <p className="cards-content-text pb-2">
                                    {postContent?.content_bn.slice(0, 130)},
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

export default FifthAndSixthCard;
