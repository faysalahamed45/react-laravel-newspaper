import React, { memo } from "react";
import Moment from "react-moment";

const MomentTo = ({ date }) => {
	// const dat = "2022-06-16T08:59-0500";
    return (
        <>
            <div>
                <Moment locale="bn" to={date} />
            </div>
        </>
    );
};

export default memo(MomentTo);
