const initialState = {
  email: ''
};

export const email = (state = initialState, action) => {
  switch (action.type) {
    case "setEmail":
      return {
        ...state,
        email: action.email
      };

    default:
      return state;
  }
};
