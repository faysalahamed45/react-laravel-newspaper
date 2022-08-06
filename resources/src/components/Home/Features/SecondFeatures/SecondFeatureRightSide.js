import React from "react";
import { Link } from "react-router-dom";
import MomentTo from "../../../../MomentJs/MomentTo";

const SecondFeatureRightSide = ({ secondFeatures }) => {
    return (
        <div>
            <div className="col-12 row-2nd">
                <hr />
                {secondFeatures?.slice(6, 7).map((propsContent) => {
                    return (
                        <div key={propsContent.id} className="cards">
                            <Link to={`/${propsContent?.slug_bn}`}>
                                <div className="img">
                                    <img
                                        className="d-inline-block h-100 w-100 img"
                                        src={propsContent?.image_url}
                                        alt=""
                                    />
                                </div>
                                <p className="cards-title-3 pt-2 pb-2">
                                    {propsContent?.title_bn.slice(0, 120)}
                                </p>
                                <p className="cards-content-text-time">
                                    <MomentTo
                                        date={propsContent?.published_at}
                                    />
                                </p>
                            </Link>
                        </div>
                    );
                })}

                <hr />
            </div>
            <div className="col-12">
                {secondFeatures?.slice(7, 8).map((propsContent) => {
                    return (
                        <div key={propsContent.id} className="cards">
                            <Link to={`/${propsContent?.slug_bn}`}>
                                <div className="float-img ms-2 overflow-hidden">
                                    <img
                                        className="d-inline-block h-100 w-100 img-fluid"
                                        src={propsContent?.image_url}
                                        alt=""
                                    />
                                </div>
                                <div className="">
                                    <p className="cards-title-3 pb-2">
                                        {propsContent?.title_bn.slice(0, 120)}
                                    </p>
                                    <p className="cards-content-text-time justify-content-between">
                                        <MomentTo
                                            date={propsContent?.published_at}
                                        />
                                    </p>
                                </div>
                            </Link>
                        </div>
                    );
                })}
            </div>
        </div>
    );
};

export default SecondFeatureRightSide;
