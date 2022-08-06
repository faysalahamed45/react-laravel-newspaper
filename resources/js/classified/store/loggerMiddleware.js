const loggerMiddleware = store => next => action => {
    const result = next(action);
    console.log(store.getState(), {action}, {result}, result.meta);

    // let newAction = Object.assign({}, action, {
    //     payload: result.meta.requestStatus
    // });
    // delete newAction.meta;
    // store.dispatch({type: 'set_status', payload: result.meta.requestStatus});

    return result;
};

export default loggerMiddleware;
