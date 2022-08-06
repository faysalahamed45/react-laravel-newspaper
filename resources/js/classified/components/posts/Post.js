import {useDispatch, useSelector} from "react-redux";
import {useEffect} from "react";

export default function Post({section, className}) {
    const dispatch = useDispatch();

    const {data: posts, status} = useSelector(state => state.posts);
    useEffect(() => {
        // dispatch(getPosts());
    }, [dispatch]);

    return (
        <div className={className}>
            <div className="text-center">
                <div className="card-box-title">{section.title}</div>
            </div>
            {section.posts.map((item, index) => (
                <div key={item.id} className={index !== 0 ? "mt-4" : ""}>
                    <div className="card-box-body text-start mt-2" dangerouslySetInnerHTML={{__html: item.body}} />
                </div>
            ))}
        </div>
    );
}
