// This declares svg's, allowing for svg imports within this file (needed for maps)
declare module '*.svg' {
    const content: string;
    export default content;
}
declare module '*.svg?raw' {
    const content: string;
    export default content;
}