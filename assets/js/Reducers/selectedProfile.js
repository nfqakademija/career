const initialState = {
  id: null
};

export const selectedProfile = (state = initialState, action) => {
  switch (action.type) {
    case "setSelectedProfile":
      return {
        ...state,
        id: action.profile
      };

    default:
      return state;
  }
};
