import React, { memo } from "react";
import Moment from "react-moment";

const MomentConverter = ({ date, formate }) => {
    console.log(date);
    return (
        <>
            {/* <Moment locale="bn" date={date} format='dddd, LL'/> */}
            {/* <Moment locale="bn" date={date} format='LL, HH:mm'/> */}
            {/* <Moment locale="bn" date={date} format='LLL'/> */}
            <Moment locale="bn" date={date} format={formate} />
        </>
    );
};

export default memo(MomentConverter);
