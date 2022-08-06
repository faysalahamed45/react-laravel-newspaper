export default function HighlightedPost({posts, className}) {
    return (
        <>
            {posts &&
                posts.map(item => (
                    <div key={item.id} className="col-6 col-md-4 card-box mb-4">
                        <div className={"text-center cardBox " + className}>
                            <div className="card-box-title">{item.category.name}</div>
                            <div key={item.id} className="card-box2">
                                <div className="card-box-body text-start mt-2 ps-2 pe-2" dangerouslySetInnerHTML={{__html: item.content}} />
                            </div>
                        </div>
                    </div>
                ))}
        </>
    );
}
