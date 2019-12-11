const initialState = {
  selected: false,
};

export const managerPage = (state = initialState, action) => {
  switch (action.type) {
    case "setSelectedProfile":
      return {
        ...state,
        selected: action.profile
      };

    default:
      return state;
  }
};
